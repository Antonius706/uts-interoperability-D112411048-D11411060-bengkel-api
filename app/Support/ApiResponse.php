<?php

namespace App\Support;

use DOMDocument;
use DOMElement;
use Illuminate\Http\Request;

class ApiResponse
{
    /** Tentukan format dari header Accept. Default JSON. */
    public static function format(Request $request): string
    {
        $accept = strtolower((string) $request->header('Accept', ''));

        $xml = strpos($accept, 'application/xml') !== false || strpos($accept, 'text/xml') !== false;
        $json = strpos($accept, 'application/json') !== false;

        if ($xml && (!$json || strpos($accept, 'xml') < strpos($accept, 'json'))) {
            return 'xml';
        }

        return 'json';
    }

    /** Buat response dengan format konsisten (JSON saja atau XML saja). */
    public static function make(Request $request, $data = null, int $status = 200, string $message = 'OK', array $headers = [])
    {
        $payload = [
            'status'  => $status >= 200 && $status < 300 ? 'success' : 'error',
            'code'    => $status,
            'message' => $message,
            'data'    => $data,
        ];

        if (self::format($request) === 'xml') {
            return response(self::toXml($payload), $status, array_merge(['Content-Type' => 'application/xml; charset=UTF-8'], $headers));
        }

        return response()->json($payload, $status, $headers);
    }

    public static function toXml(array $payload, string $root = 'response'): string
    {
        $doc = new DOMDocument('1.0', 'UTF-8');
        $doc->formatOutput = true;
        $rootEl = $doc->createElement($root);
        $doc->appendChild($rootEl);
        self::append($doc, $rootEl, $payload);

        return $doc->saveXML();
    }

    private static function append(DOMDocument $doc, DOMElement $parent, $value): void
    {
        if (is_object($value) && method_exists($value, 'toArray')) {
            $value = $value->toArray();
        }

        if (is_array($value)) {
            $isList = array_keys($value) === range(0, count($value) - 1);
            foreach ($value as $key => $child) {
                $name = $isList ? 'item' : self::safeName((string) $key);
                $el = $doc->createElement($name);
                $parent->appendChild($el);
                self::append($doc, $el, $child);
            }
            return;
        }

        if (is_bool($value)) {
            $value = $value ? 'true' : 'false';
        }
        if ($value !== null) {
            $parent->appendChild($doc->createTextNode((string) $value));
        }
    }

    private static function safeName(string $key): string
    {
        $key = preg_replace('/[^A-Za-z0-9_\-.]/', '_', $key);
        return preg_match('/^[A-Za-z_]/', $key) ? $key : '_' . $key;
    }
}
