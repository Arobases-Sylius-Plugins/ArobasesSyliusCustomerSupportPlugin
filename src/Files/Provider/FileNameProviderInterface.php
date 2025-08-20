<?php

declare(strict_types=1);

namespace Arobases\SyliusCustomerSupportPlugin\Files\Provider;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface FileNameProviderInterface
{
    /**
     * Génère un nom de fichier unique dans un chemin donné
     *
     * @param UploadedFile $file      Le fichier uploadé
     * @param string       $pathFile  Le chemin où vérifier l’existence
     *
     * @return string Nom de fichier unique
     */
    public function getFileName(UploadedFile $file, string $pathFile): string;
}
