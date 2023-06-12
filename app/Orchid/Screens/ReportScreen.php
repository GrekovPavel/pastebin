<?php

namespace App\Orchid\Screens;

use App\Models\Report;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Toast;


class ReportScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(Report $report): array
    {
        return [
            "report" => $report->paginate(10)
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Жалобы';
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): array
    {
        return [
            Layout::table('report', [
                TD::make('id', 'id Жалобы'),
                TD::make('paste_id', 'id Пасты'),
                TD::make('reason', 'Причина'),
            ]),
        ];
    }
}
