<?php

declare(strict_types=1);


namespace Arobases\SyliusCustomerSupportPlugin\Files\Provider;


use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;

final class FileNameProvider {

    private Filesystem $fileSystem;

    public function __construct(Filesystem $fileSystem)
    {
        $this->fileSystem = $fileSystem;
    }

    public function getFileName(UploadedFile $file, string $pathFile): string
    {
        $baseFileName = $file->getClientOriginalName();
        $cpt =0;
        $fileName =$baseFileName;
        while($this->fileSystem->exists($pathFile .$fileName))
        {
            $cpt++;
            $explodedFileName = explode('.', $baseFileName);
            $extension = array_pop($explodedFileName);
            $fileName = implode('.', $explodedFileName) ."_". $cpt . ".".$extension ;
        }
        return $fileName;
    }
}
