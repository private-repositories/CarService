<?php declare(strict_types=1);

/**
 * Title           : CarService
 * Filename        : ImportController.php
 * Description     :
 * Date            : 08/09/19 10:00
 * Author          : dave.gillard
 * Copyright       : 2019 All rights reserved
 */

namespace DavegTheMighty\CarService\Controller;

//phpcs:ignore PSR2.Namespaces.UseDeclaration.MultipleDeclarations
use DavegTheMighty\CarService\Model\{
    Owner,
    Vehicle
};

use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException as QE;

use Interop\Container\ContainerInterface;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

use Slim\Http\UploadedFile;

class ImportController
{
    /**
     * @param Request $request
     * @param ResponseInterface $response
     * @param array $args
     * @return ResponseInterface
     */

    protected $file_errors = false;
    protected $row = 0;

    /**
     * GenericModelController constructor.
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->logger = $container->logger;
        $this->validator = $container->validator;
    }

    public function importData(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {

        $uploadedFiles = $this->uploadFiles($request);

        if (empty($uploadedFiles)) {
            return $response->withStatus(400);
        }

        foreach ($uploadedFiles as $file_name => $uploadedFile) {
            if ($uploadedFile === null) {
                $this->logger->error(
                    "Unable to upload file $file_name.",
                );
                $this->file_errors = true;
                continue;
            }

            try {
                $headers = [];
                if (($handle = fopen($uploadedFile, "r")) !== false) {
                    while (($data = fgetcsv($handle)) !== false) {
                        $this->row++;
                        if ($this->row === 1) {
                            $headers = $data;
                            continue;
                        }
                        $attributes = array_combine($headers, $data);
                        $this->importRow($attributes);
                    }
                    fclose($handle);
                }
            } catch (\Exception $e) {
                $this->logger->error(
                    "Unexpected exception raised for file '{$file_name}' import.",
                    [$e]
                );
                $this->file_errors = true;
            }
        }

        if ($this->file_errors) {
            //TODO: Should be a 400 if validation errors only
            return $response->withStatus(500);
        }

        return $response->withStatus(201);
    }

    protected function uploadFiles(ServerRequestInterface $request): array
    {
        $uploadedFiles = [];

        $files = $request->getUploadedFiles();
        foreach ($files as $file) {
            $uploadedFiles[$file->getClientFilename()] = $this->uploadFile($file);
        }
        return $uploadedFiles;
    }

    protected function uploadFile(UploadedFile $file): ?string
    {
        //TODO: Add upload dir to settings
        $uploadPath = __DIR__.'/../../var/uploads/';
        try {
            $filename = $file->getClientFilename();
            $uploadName = sprintf('%s/%s%s', $uploadPath, $filename, time());
            $didUpload = move_uploaded_file($file->file, $uploadName);
            if ($didUpload) {
                return $uploadName;
            } else {
                $this->logger->error(
                    "Unable to import file '{$filename}' - upload not successful"
                );
                return null;
            }
        } catch (\RuntimeException $e) {
            $this->logger->error(
                "Unable to import file - move to upload directory with message: " .$e->getMessage()
            );
            return null;
        }
    }

    protected function importRow(array $attributes)
    {

        $vehicle = new Vehicle(['id' => Vehicle::generateId()]);
        $vehicle->fill($attributes);

        //Check if owner already exists
        try {
            $owner = Owner::where(['owner_name' => $attributes['owner_name']])->firstOrFail();
        } catch (ModelNotFoundException $e) {
            $owner = new Owner(['id' => Owner::generateId()]);
            $owner->fill($attributes);
        }

        //Associate Owner with Vehicle
        $vehicle->owner()->associate($owner);

        $errors = array_merge_recursive(
            $owner->validate($this->validator),
            $vehicle->validate($this->validator),
        );

        //If validation not empty
        if (!empty($errors)) {
            $this->logger->info(
                "Validation errors raised for vehicle import row '{$this->row}' request, not saving.",
                [$errors]
            );
            $this->file_errors = true;
            return;
        }

        try {
            DB::transaction(function () use ($owner, $vehicle) {
                $owner->save();
                $vehicle->save();
            }, 3);
        } catch (QE $queryException) {
            $this->logger->error(
                "Database operation on Vehicles import for row {$this->row} failed with db query errors.",
                [$queryException]
            );
            $this->file_errors = true;
        } catch (\PDOException $pdoException) {
            $this->logger->error(
                "Unable to complete database operation on Vehicles import for row {$this->row}",
                [$pdoException]
            );
            $this->file_errors = true;
        }
    }
}
