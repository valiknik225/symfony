<?php

namespace App\Shortener\Services;

    use App\Shortener\Exceptions\DataNotFoundException;
    use App\Shortener\Interfaces\IShortenerRepository;
    use App\Shortener\Interfaces\IUrlEncoder;
    use App\Shortener\Interfaces\IUrlValidator;
    use InvalidArgumentException;

    class UrlEncodeServices implements IUrlEncoder
    {
        const CHARSET = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        const LENGTH = 10;

        public function __construct(
            protected IUrlValidator $urlValidator,
            protected IShortenerRepository $repository,
            protected int $lengthCode = self::LENGTH,
            protected string $charset = self::CHARSET
        )
        {
            //
        }

        /**
     * @param string $url
     * @return string
     * @throws InvalidArgumentException
     */

    public function encode(string $url): string
    {
        $this->validateUrl($url);

        try {
            $code = $this->repository->getCodeByUrl($url);
        } catch (DataNotFoundException $exception) {
            $code = $this->generateCode();
            $this->repository->addNewUrl($code, $url);
        }

        return $code;
    }

    protected function generateCode(): string
    {
        $length = strlen($this->charset);

        do {
            $code = '';
            for ($i = 0; $i < $this->lengthCode; $i++) {
                $code .= $this->charset[rand(0, $length - 1)];
            }
        } while ($this->repository->codeIsset($code));

        return $code;
    }

    /**
     * @param string $url
     * @return void
     * @throws InvalidArgumentException
     */
    protected function validateUrl(string $url): void
    {
        $this->urlValidator->validateUrl($url);
        $this->urlValidator->validateIsRealUrl($url);
    }
}