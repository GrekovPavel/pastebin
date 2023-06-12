<?php

namespace App\Orchid\Screens;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Toast;


class ClientScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(User $user): array
    {
        return [
            "user" => $user->paginate(10)
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Пользователи';
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
            Layout::table('user', [
                TD::make('id', 'id'),
                TD::make('name', 'Логин'),
                TD::make('email', 'Емайл'),
                TD::make('password', 'Пароль'),
                TD::make('banned', 'Пользователь забанен?'),
                TD::make('action')->render(function (User $user) {
                    return ModalToggle::make('Забанить')
                        ->modal('banClient')
                        ->method('ban')
                        ->modalTitle('Забанить пользователя? ' . $user->name)
                        ->asyncParameters([
                            'user' => $user->id
                        ]);
                }),
                TD::make('action')->render(function (User $user) {
                    return ModalToggle::make('Разбанить')
                        ->modal('unBanClient')
                        ->method('unBan')
                        ->modalTitle('Разбанить пользователя? ' . $user->name)
                        ->asyncParameters([
                            'user' => $user->id
                        ]);
                }),
            ]),
            Layout::modal('banClient', Layout::rows([
                Input::make('user.id')->type('hidden')
            ]))->async('asyncGetClient'),
            Layout::modal('unBanClient', Layout::rows([
                Input::make('user.id')->type('hidden')
            ]))->async('asyncGetClient')
        ];
    }

    public function asyncGetClient(User $user): array
    {
        return [
            'user' => $user
        ];
    }

    public function ban(Request $request)
    {
        DB::table('users')
            ->where('id', '=', $request->input('user.id'))
            ->update(['banned' => true]);

        Toast::info('Пользователь забанен');
    }

    public function unBan(Request $request)
    {
        DB::table('users')
            ->where('id', '=', $request->input('user.id'))
            ->update(['banned' => false]);

        Toast::info('Пользователь разбанен');
    }
}
