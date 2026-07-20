<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class RolesFilters implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }

        $userRole = session()->get('idRoles');

        if (!empty($arguments)) {
            if (!in_array($userRole, $arguments)) {
                return redirect()->to('/')->with('error', 'Accès refusé : vous n\'avez pas les permissions nécessaires.');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {}
}
