<?php

namespace App\Shortener\Repository;

use App\Shortener\Exceptions\DataNotFoundException;
use App\Shortener\Exceptions\FileNotFoundException;
use App\Shortener\Interfaces\IShortenerRepository;

class FileRepository implements IShortenerRepository
{
    protected array $data;

    /**
     * @throws FileNotFoundException
     */
    public function __construct(protected string $path)
    {
        $this->validateFilePath($path);
        $this->data = $this->readFile();
    }

    /**
     * @param string $code
     * @return string
     * @throws DataNotFoundException
     */
    public function getUrlByCode(string $code): string
    {
        if (!$this->codeIsset($code)) {
            throw new DataNotFoundException();
        }
        return $this->data[$code];
    }

    /**
     * @param string $url
     * @return string|int
     * @throws DataNotFoundException
     */
    public function getCodeByUrl(string $url): string|int
    {
        if (!($code = array_search($url, $this->data))) {
            throw new DataNotFoundException();
        }
        return $code;
    }

    public function codeIsset(string $code): bool
    {
        return isset($this->data[$code]);
    }

    public function addNewUrl(string $code, string $url): void
    {
        $this->data[$code] = $url;
    }

    /**
     * @throws FileNotFoundException
     */
    protected function validateFilePath(string $path): void
    {
        if (!file_exists($path)) {
            throw new FileNotFoundException("File $path not found.");
        }
    }

    protected function readFile(): array
    {
        $json = file_get_contents($this->path);
        return (array)json_decode($json, true);
    }

    protected function writeDataToFile(): void
    {
        $json = json_encode($this->data, JSON_PRETTY_PRINT);
        file_put_contents($this->path, $json);
    }

    public function __destruct()
    {
        $this->writeDataToFile();
    }
}