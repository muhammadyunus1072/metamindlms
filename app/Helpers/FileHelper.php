<?php

namespace App\Helpers;

class FileHelper
{
    const WEBSITE_USER = 'http://localhost:8000';

    const IMAGE_PATH = '/attachments/images/';
    const U_IMAGE_PATH = 'attachments/images/';

    const FILE_PATH = '/attachments/files/';
    const U_FILE_PATH = 'attachments/files/';

    // SAVE FILE
    const COURSE_SAVE_LOCATION = self::U_FILE_PATH . 'course';

    // READ FILE
    const COURSE_READ_LOCATION = self::WEBSITE_USER . self::FILE_PATH . 'course/';

}
