<?php
declare(strict_types = 1);

namespace EPS\PhpUri\Validator\Patterns;

interface Rfc3986
{
    public const URI_UNPACK_PATTERN = '/^(([^:\/?#]+):)(\/\/([^\/?#]*))?([^?#]*)(\?([^#]*))?(#(.*))?/';

    public const ALPHA = 'A-Za-z';
    public const DIGIT = '0-9';
    public const HEX = self::DIGIT . 'A-Fa-f';
    public const PCT_ENCODED = '%' . self::HEX . self::HEX;
    public const PCHAR = '[' . self::UNRESERVED . self::DELIMITERS . ':@]|' . self::PCT_ENCODED;
    public const OCTET = '(?:[' . self::DIGIT . ']|[1-9][' . self::DIGIT . ']|1[' . self::DIGIT . ']{2}|2[0-4]' . self::DIGIT . '|25[0-5])';
    public const H16 = '[' . self::HEX . ']{1,4}';
    public const LS32 = '(' . self::H16 . ':' . self::H16 . '|' . self::IPV4 . ')';
    public const IPV4 = '(?>(' . self::OCTET . '\.' . self::OCTET . '\.' . self::OCTET . '\.' . self::OCTET . '))';
    public const IPV6 = '(?:' . '((?:' . self::H16 . ':){6}' . self::LS32 . ')|' .
        '(?:::(?:' . self::H16 . ":){5}" . self::LS32 . ")|" .
        '(?:(?:' . self::H16 . ")?::(?:" . self::H16 . ":){4}" . self::LS32 . ")|" .
        '(?:(?:(?:' . self::H16 . ":){0,1}" . self::H16 . ")?::(?:" . self::H16 . ":){3}" . self::LS32 . ")|" .
        '(?:(?:(?:' . self::H16 . ":){0,2}" . self::H16 . ")?::(?:" . self::H16 . ":){2}" . self::LS32 . ")|" .
        '(?:(?:(?:' . self::H16 . ":){0,3}" . self::H16 . ")?::" . self::H16 . ":" . self::LS32 . ")|" .
        '(?:(?:(?:' . self::H16 . ":){0,4}" . self::H16 . ")?::" . self::LS32 . ")|" .
        '(?:(?:(?:' . self::H16 . ":){0,5}" . self::H16 . ")?::" . self::H16 . ")|" .
        '(?:(?:(?:' . self::H16 . ":){0,6}" . self::H16 . ")?::))";

    public const SEGMENT = '(?>(?:' . self::PCHAR . ')*)';
    public const SEGMENT_NZ = '(?>(?:' . self::PCHAR . ')+)';
    public const SEGMENT_NZ_NC = '(?>(?:[' . self::UNRESERVED . self::DELIMITERS . '@]++|' . self::PCT_ENCODED . ')+)';

    public const PATH_ABEMPTY = '(?:\/' . self::SEGMENT . ')';
    public const PATH_ABSOLUTE = '(?:\/(' . self::SEGMENT_NZ . '(\/' . self::SEGMENT . ')*))';
    public const PATH_NOSCHEME = '(?:' . self::SEGMENT_NZ_NC . '(\/' . self::SEGMENT . ')*)';
    public const PATH_ROOTLESS = '(?:' . self::SEGMENT_NZ . '(\/' . self::SEGMENT . ')*)';
    public const PATH_EMPTY = '()';
    public const PATH = self::PATH_ABEMPTY . '|' . self::PATH_ABSOLUTE . '|' . self::PATH_ROOTLESS . self::PATH_EMPTY;

    public const REGNAME = '(?>([' . self::DELIMITERS . self::UNRESERVED . ']++|' . self::PCT_ENCODED .')*)';
    public const HOST = '(' . self::IPV4 . '|' . self::REGNAME . ')';

    public const USERINFO = '(?>([' . self::UNRESERVED . self::DELIMITERS . ':]++|' . self::PCT_ENCODED .')*)';
    public const PORT = '(?>[' . self::DIGIT . ']+)';
    public const AUTHORITY = '(?:' . self::USERINFO . '@)?' . self::HOST . '(' . self::PORT . ')?';
    public const QUERY = '(?:(?>(' . self::PCHAR . '|[\?])*))';
    public const FRAGMENT = '(?:(?>(' . self::PCHAR . '|[\?])*))';

    public const UNRESERVED = self::ALPHA . self::DIGIT . '\-\._~';
    public const DELIMITERS = '!$&\'()*+,;=';
    public const SCHEME = '[' . self::ALPHA . '][' . self::ALPHA . self::DIGIT . '\+\-\.]*';

    public const GEN_DELIMITERS = ':/?#[]@';
}
