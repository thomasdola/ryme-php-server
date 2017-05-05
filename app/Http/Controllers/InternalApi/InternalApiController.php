<?php
namespace App\Http\Controllers\InternalApi;

use App\Http\Controllers\Controller;
use Eureka\Helpers\Utils\UploadFile;

class InternalApiController extends Controller
{
    const BASE_URL = 'localhost:8000/admin/internal';
    const USER_UPLOADS_PATH = '/public/users/uploads/';
    const ADS_UPLOADS_PATH = '/public/ads/uploads/';
    use UploadFile;
}