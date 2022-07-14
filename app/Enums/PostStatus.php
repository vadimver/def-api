<?php

namespace App\Enums;

enum PostStatus: string
{
    case CREATED = 'created';
    case MODERATED = 'moderated';
    case PUBLISHED = 'published';
}
