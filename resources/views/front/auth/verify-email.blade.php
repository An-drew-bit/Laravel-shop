@extends('layouts.auth.layout')

@section('title', 'Подтверждение почты')

@section('content')
    <div class="max-w-[640px] mt-12 mx-auto p-6 xs:p-8 md:p-12 2xl:p-16 rounded-[20px] bg-purple">
        <h1 class="mb-5 text-lg font-semibold">Подтверждение почты</h1>
        <form class="space-y-3" method="post" action="{{ route('verification.send') }}">
            @csrf

            <x-forms.primary-button>Отправить повторно</x-forms.primary-button>
        </form>
        <ul class="flex flex-col md:flex-row justify-between gap-3 md:gap-4 mt-14 md:mt-20">
            <li>
                <a href="#" class="inline-block text-white hover:text-white/70 text-xxs md:text-xs font-medium"
                   target="_blank" rel="noopener">Необходимо подтверждение email</a>
            </li>
            <li class="hidden md:block">
                <div class="h-full w-[2px] bg-white/20"></div>
            </li>
            <li>
                <a href="#" class="inline-block text-white hover:text-white/70 text-xxs md:text-xs font-medium"
                   target="_blank" rel="noopener">Письмо отправлено почту</a>
            </li>
        </ul>
    </div>
@endsection
