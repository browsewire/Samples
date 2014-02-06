<?php
/*** DESCRIPTION 
|
|   controlling our tour page
|   e.g http://www.domain.com/tour
|   will be directed to view\tour\index.php
|   and handled thorugh action_index() function
|
***/

class Tour_Controller extends Base_Controller
{
    public function action_index()
    {
        return View::make('tour.index');
    }

    public function action_create()
    {
        return View::make('tour.create');
    }

    public function action_contacts()
    {
        return View::make('tour.contacts');
    }

    public function action_pdf()
    {
        return View::make('tour.pdf');
    }

    public function action_settings()
    {
        return View::make('tour.settings');
    }

}