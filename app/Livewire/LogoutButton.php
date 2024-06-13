<?php

namespace App\Livewire;

use Livewire\Component;
use App\Livewire\Actions\Logout as PerformLogout;

class LogoutButton extends Component
{

    public function logout(){
        $logout = new PerformLogout();
        $logout();
        return redirect('/');
    }
    public function render()
    {
        return view('livewire.logout-button');
    }
}
