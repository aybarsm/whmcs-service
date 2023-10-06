<?php

namespace Aybarsm\Whmcs\Service\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;

trait Macros
{
    public static function registerMacros(): void
    {
        if (Arr::get(static::$init, 'macros') === true){
            return;
        }

        Arr::macro('undot', function ($array): array
        {
            $results = [];

            foreach ($array as $key => $value) {
                static::set($results, $key, $value);
            }

            return $results;
        });

        Arr::macro('map', function (array $array, callable $callback)
        {
            $keys = array_keys($array);

            try {
                $items = array_map($callback, $array, $keys);
            } catch (\ArgumentCountError $exception) {
                $items = array_map($callback, $array);
            }

            return array_combine($keys, $items);
        });

        Arr::macro('mapWithKeys', function (array $array, callable $callback): array
        {
            $result = [];

            foreach ($array as $key => $value) {
                $assoc = $callback($value, $key);

                foreach ($assoc as $mapKey => $mapValue) {
                    $result[$mapKey] = $mapValue;
                }
            }

            return $result;
        });

        Arr::macro('toXml', function (array $data, string $root = '', ?\SimpleXMLElement $xml = null): \SimpleXMLElement
        {
            if ($xml === null) {
                $xml = new \SimpleXMLElement(empty($root) ? '' : '<' . $root . '/>');
            }

            foreach ($data as $key => $value) {
                if (is_array($value)) {
                    static::toXml($value, $key, $xml->addChild($key));
                } else {
                    $xml->addChild($key, htmlspecialchars($value));
                }
            }

            return $xml;
        });

        Arr::macro('fromXml', function (string $content, bool $avoidEmpty = true, $replaceEmpty = ''): array
        {
            $xml = simplexml_load_string($content, "SimpleXMLElement", LIBXML_NOEMPTYTAG);

            if($xml === false){
                return [];
            }

            $data = json_decode(json_encode($xml), true);

            return $avoidEmpty ? static::undot(static::map(static::dot($data), fn ($value) => is_array($value) && empty($value) ? $replaceEmpty : $value)) : $data;
        });

        Stringable::macro('value', fn (): string => static::__toString());

        Str::macro('wrap', fn (string $value, string $before, ?string $after = null): string => $before.$value.($after ?? $before));
        Stringable::macro('wrap', fn (string $before, ?string $after = null): Stringable => Str::of(Str::wrap(static::__toString(), $before, $after)));

        Str::macro('wrapSafe', function (string $value, string $before = '', string $after = ''): string {
            if (empty($before) && empty($after)) {
                return $value;
            }

            return static::of($value)->start($before)->finish($after)->__toString();
        });

        Stringable::macro('wrapSafe', fn (string $before = '', string $after = ''): Stringable => Str::of(Str::wrapSafe(static::__toString(), $before, $after)));

        Str::macro('squish', fn ($value) => preg_replace('~(\s|\x{3164}|\x{1160})+~u', ' ', preg_replace('~^[\s\x{FEFF}]+|[\s\x{FEFF}]+$~u', '', $value)));

        Stringable::macro('squish', fn (): Stringable => Str::of(Str::squish(static::__toString())));

        Arr::macro('toForm', function (array $config, bool $pretty = false): string
        {
            $sep = $pretty ? "\n" : '';

            $form = Str::of(implode(' ', Arr::map(($config['form'] ?? []), fn ($val, $key) => Str::wrap($val, $key . '="', '"'))))
                ->squish()
                ->wrap('<form ', ">{$sep}")->
                __toString();

            $inputs = implode('', Arr::map(($config['inputs'] ?? []), fn ($val, $key) => Str::of(
                Str::of($key)->before(':')->wrap('type="', '"')->__toString() . ' ' .
                Str::of($key)->after(':')->wrap('name="', '"')->value() . ' ' .
                Str::of($key)->after(':')->wrap('id="', '"')->value() . ' ' .
                Str::wrap($val, 'value="', '"'),
            )
                ->squish()
                ->wrap('<input ', ">{$sep}")
                ->__toString()
            ));

            $prefix = $config['prefix'] ?? '';
            $suffix = $config['suffix'] ?? '';

            return "{$prefix}{$sep}{$form}{$inputs}</form>{$sep}{$suffix}";

        });

        Stringable::macro('whenNotEmpty', function (callable $callback): Stringable {
            if (! $this->isEmpty()) {
                $result = $callback($this);

                return is_null($result) ? $this : $result;
            }

            return $this;
        });

        Arr::macro('wrapKeys', function (array $data, string $before = '', string $after = ''): array
        {
            return static::mapWithKeys($data, fn ($item, $key) => [Str::wrapSafe($key, $before, $after) => $item]);
        });

        // Courtesy of Laravel
        Stringable::macro('when', function ($value, callable $callback = null, callable $default = null)
        {
            $value = $value instanceof \Closure ? $value($this) : $value;

            if ($value) {
                return $callback($this, $value) ?? $this;
            } elseif ($default) {
                return $default($this, $value) ?? $this;
            }

            return $this;
        });

        // Courtesy of Laravel
        Stringable::macro('unless', function ($value, callable $callback = null, callable $default = null)
        {
            $value = $value instanceof \Closure ? $value($this) : $value;

            if (! $value) {
                return $callback($this, $value) ?? $this;
            } elseif ($default) {
                return $default($this, $value) ?? $this;
            }

            return $this;
        });

        Arr::set(static::$init, 'macros', true);
    }

}