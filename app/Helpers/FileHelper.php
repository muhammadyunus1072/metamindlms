<?php

namespace App\Helpers;

class FileHelper
{
    // const WEBSITE_USER = 'https://metamind-lms.smartisdev.com';
    const WEBSITE_USER = 'https://metamind.imanity.tech';

    const U_IMAGE_PATH = 'attachments/images/';
    const U_FILE_PATH = 'attachments/files/';

    const IMAGE_PATH = '/'.self::U_IMAGE_PATH;
    const FILE_PATH = '/'.self::U_FILE_PATH;


    // SAVE FILE
    const COURSE_SAVE_LOCATION = self::U_FILE_PATH . 'course/';
    const OFFLINE_COURSE_SAVE_LOCATION = self::FILE_PATH . 'offline_course/';
    const PROOF_OF_PAYMENT_SAVE_LOCATION = self::FILE_PATH . 'proof_of_payment/';

    // READ FILE
    const COURSE_READ_LOCATION = self::WEBSITE_USER . self::FILE_PATH . 'course/';
    const OFFLINE_COURSE_READ_LOCATION = self::WEBSITE_USER . self::FILE_PATH . 'offline_course/';
    const PROOF_OF_PAYMENT_READ_LOCATION = self::WEBSITE_USER . self::FILE_PATH . 'proof_of_payment/';
}
