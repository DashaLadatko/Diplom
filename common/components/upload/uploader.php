<?php

namespace common\components\upload;

/**
 * Class uploader
 * @package common/components/upload
 *
 * @property string $folder
 * @property string $module
 * @property int $default_name_length
 * @property array $default_image
 * @property array $typePath
 */
class uploader
{
    const TYPE_MINIATURE = 'miniature';
    const TYPE_IMAGE = 'image';
    const TYPE_DOCUMENT = 'document';
    const TYPE_VIDEO = 'video';
    const TYPE_AUDIO = 'audio';
    const TYPE_ARCHIVE = 'archive';
    const TYPE_UNKNOWN = 'unknown';

    const TYPE_ALL = 'all';

    const ALL_TYPES = [
        self::TYPE_DOCUMENT => [
            'pdf',
            'doc',
            'txt',
            'xlsx',
            'xls'
        ],
        self::TYPE_IMAGE => [
            'png',
            'jpg',
            'gif',
            'jpeg',
        ],
        self::TYPE_VIDEO => [
            'mkv',
            'avi',
            'wmv',
            'mpeg',
            'mp4',
            'ogg',
            'webm',
            '3gpp',
            '3gpp2',
        ],
        self::TYPE_AUDIO => [
            'mp3',
            'wma',
            'wav',
        ],
        self::TYPE_ARCHIVE => [
            'zip',
            'rar',
        ],
        self::TYPE_UNKNOWN => [],
    ];

    public $folder;

    public $module = 'static';

    public $default_name_length = 10;

    public $default_image = [];

    public $typePath = [
        self::TYPE_IMAGE => '/image/',
        self::TYPE_DOCUMENT => '/document/',
        self::TYPE_MINIATURE => '/miniature/',
        self::TYPE_UNKNOWN => '/unknown/',
        self::TYPE_VIDEO => '/video/',
        self::TYPE_AUDIO => '/audio/',
        self::TYPE_ARCHIVE => '/archive/',
    ];
}