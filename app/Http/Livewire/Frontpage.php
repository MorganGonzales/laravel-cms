<?php

namespace App\Http\Livewire;

use App\Models\Page;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Frontpage extends Component
{
    public $title;
    public $content;

    public function mount($urlslug = null)
    {
        $this->retrieveContent($urlslug);
    }

    public function retrieveContent($urlslug)
    {
        if (!$urlslug) {
            $data = Page::firstWhere('is_default_home', true);
        } else {
            $data = Page::firstWhere('slug', $urlslug);

            if (!$data) {
                $data = Page::firstWhere('is_default_not_found', true);
            }
        }

        $this->title = $data->title;
        $this->content = $data->content;
    }

    public function render()
    {
        return view('livewire.frontpage', [
            'sidebarLinks' => $this->sideBarLinks(),
            'topNavLinks' => $this->topNavLinks(),
        ])->layout('layouts.frontpage');
    }

    private function sideBarLinks()
    {
        return DB::table('navigation_menus')
            ->where('type', 'SidebarNav')
            ->orderBy('sequence')
            ->orderBy('created_at')
            ->get();
    }

    private function topNavLinks()
    {
        return DB::table('navigation_menus')
            ->where('type', 'TopNav')
            ->orderBy('sequence')
            ->orderBy('created_at')
            ->get();
    }
}
