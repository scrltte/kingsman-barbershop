<?php
namespace App\Controllers;

use App\Core\Controller;

class ContactController extends Controller {
    public function index(): void {
        $this->render('contacts/index');
    }
}