<?php

    define('SITE_NAME','Food Ordering Admin');
    define('FRONT_SITE_NAME','Food Online');


    /*Create Hard Code PATH which we use image file when we add or edit or upload image*/
//===================================================================================================//
     //---------------------------------------------------------------------------------------//
        //create 'SERVER_PATH' that use to create 'DISH_IMAGE_SERVER_PATH' 
        define('SERVER_PATH',$_SERVER['DOCUMENT_ROOT'].'/new_project/Food_Ordering_Project/');

        ////create 'SITE_PATH' that use to create 'DISH_IMAGE_SITE_PATH'
        define('SITE_PATH','http://localhost/new_project/Food_Ordering_Project/');
    //-----------------------------------------------------------------------------------------//

   
    //-------------------------------------------------------------------------------------//
        //This 'DISH_IMAGE_SERVER_PATH' is use when add/edit/upload image file
        define('DISH_IMAGE_SERVER_PATH',SERVER_PATH.'media/dish/');

        //This 'DISH_IMAGE_SITE_PATH' is use when show image file
        define('DISH_IMAGE_SITE_PATH',SITE_PATH.'media/dish/');
    //-------------------------------------------------------------------------------------//


    //-------------------------------------------------------------------------------------//
        //This 'BANNER_IMAGE_SERVER_PATH' is use when add/edit/upload image file
        define('BANNER_IMAGE_SERVER_PATH',SERVER_PATH.'media/banner/');

        //This 'BANNER_IMAGE_SITE_PATH' is use when show image file
        define('BANNER_IMAGE_SITE_PATH',SITE_PATH.'media/banner/');
    //-------------------------------------------------------------------------------------//
//=============================================================================================//

?>