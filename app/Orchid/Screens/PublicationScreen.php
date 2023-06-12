<?php

namespace App\Orchid\Screens;

use App\Models\Paste;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class PublicationScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(Paste $paste): iterable
    {
        return [
            'paste' => $paste->paginate(10)
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Пасты';
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::table('paste', [
                TD::make('id', 'id'),
                TD::make('content', 'Паста'),
                TD::make('link', 'Ссылка'),
                TD::make('expiration_time', 'Время жизни'),
                TD::make('access_paste', 'Доступ к пасте'),
                TD::make('action')->render(function (Paste $paste) {
                    return ModalToggle::make('Удалить')
                        ->modal('deletePaste')
                        ->method('delete')
                        ->modalTitle('Удалить пасту? id ' . $paste->id)
                        ->asyncParameters([
                            'paste' => $paste->id
                        ]);
                }),
            ]),
            Layout::modal('deletePaste', Layout::rows([
                Input::make('paste.id')->type('hidden')
            ]))->async('asyncGetPaste'),
        ];
    }

    public function asyncGetPaste(Paste $paste): array
    {
        return [
            'paste' => $paste
        ];
    }

    public function delete(Request $request)
    {
        Paste::find($request->input('paste.id'))->delete();

        Toast::info('Паста удалена');
    }

}
