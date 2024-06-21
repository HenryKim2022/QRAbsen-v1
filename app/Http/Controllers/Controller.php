<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

use SimpleSoftwareIO\QrCode\Facades\QrCode;

abstract class Controller
{
    protected $pageData;
    public function __construct()
    {
        // $this->middleware('guest')->except('logout');
        $this->pageData = [
            'page_title' => 'What Public See',
            'page_url' => base_url('login-url'),
        ];
        Session::put('page', $this->pageData);
    }

    ///////////////////////////// QR SETTER ////////////////////////////
    public function genQRnonAuth($routename = '/login', $color = 'black', $sizeAt = 200)
    {
        $theURL = env('APP_URL') . $routename;
        $colorValue = $this->getColorValue($color);
        return QrCode::format('png')
            ->size($sizeAt)
            ->color($colorValue[0], $colorValue[1], $colorValue[2], $colorValue[3])
            ->generate($theURL);
    }
    public function genQR($routename = '/login', $sizeAt = 200)
    {
        $theURL = env('APP_URL') . '/dashboard/' . $routename;
        return QrCode::format('png')->size($sizeAt)->generate($theURL);
    }

    private function getColorValue($color)
    {
        $colorMap = [
            'black' => [0, 0, 0, 100],
            'red' => [255, 0, 0, 100],
        ];
        if (isset($colorMap[$color])) {
            return $colorMap[$color];
        }
        return $colorMap['black'];  // Default to black if the specified color is not found in the mapping
    }

    ///////////////////////////// PAGE SETTER ////////////////////////////
    public function setPageSession($pageTitle, $pageUrl)
    {
        $pageData = Session::get('page');
        $pageData['page_title'] = $pageTitle;
        $pageData['page_url'] = $pageUrl;

        // Store the updated array back in the session
        Session::put('page', $pageData);
        return true;
    }


    public function setReturnView($viewurl, $loadDatasFromDB = [])
    {
        $pageData = Session::get('page');
        $mergedData = array_merge($loadDatasFromDB, ['pageData' => $pageData]);
        return view($viewurl, $mergedData);
    }
}
