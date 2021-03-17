<?php

declare(strict_types=1);

namespace Terpomoj\ArgsParser;

class Tokenizer
{
    public function __invoke(string $argString): array
    {
        $str = trim($argString);
        $i = 0;

        /** @var ?string $prevC */
        $prevC = null;
        /** @var ?string $c */
        $c = null;
        /** @var ?string $opening */
        $opening = null;

        /** @var string[] $args */
        $args = [];

        for ($ii = 0, $strLength = mb_strlen($str); $ii < $strLength; $ii++) {
            $prevC = $c;

            $c = mb_substr($str, $ii, 1);

            if ($c === ' ' && !$opening) {
                if ($prevC !== ' ') {
                    $i++;
                }

                continue;
            }

            if ($c === $opening) {
                $opening = null;
            } elseif (($c === '\'' || $c === '"') && !$opening) {
                $opening = $c;
            }

            if (!array_key_exists($i, $args)) {
                $args[$i] = '';
            }

            $args[$i] .= $c;
        }

        return $args;
    }
}
