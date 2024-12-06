<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilterRole implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        $role = $session->get('role');
        if (!$role) 
            return redirect()->to(base_url('/login'));
        if ($arguments) {
            foreach ($arguments as $requiredRole) {
                if (in_array($requiredRole, $role)) {
                    return;
                }
            }
        }
        if(in_array('student', $role)){
            return redirect()->to(base_url('/home'));
        }elseif(in_array('teacher', $role)){
            return redirect()->to(base_url('/home-teacher'));
        }elseif(in_array('company', $role)){
            return redirect()->to(base_url('/home-company'));
        }else{
            return redirect()->to(base_url('/login'));
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tento filtr nepotřebuje žádné akce po vykreslení stránky
    }
}