<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            📋 История запросов
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <div class="mb-4 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-900">Все ваши запросы</h3>
                <a href="{{ route('ai.index') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition">
                    + Создать новый запрос
                </a>
            </div>
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if ($requests->count() > 0)
                        <div class="space-y-4">
                            @foreach ($requests as $request)
                                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                                    <div class="flex justify-between items-start mb-3">
                                        <div class="flex-1">
                                            <span class="inline-block bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                                                {{ $request->model_used }}
                                            </span>
                                            @if($request->status === 'completed')
                                                <span class="inline-block bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded ml-2">
                                                    ✓ Выполнено
                                                </span>
                                            @else
                                                <span class="inline-block bg-red-100 text-red-800 text-xs font-semibold px-2.5 py-0.5 rounded ml-2">
                                                    ✗ Ошибка
                                                </span>
                                            @endif
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <span class="text-gray-500 text-sm">{{ $request->created_at->format('d.m.Y H:i') }}</span>
                                            <form action="{{ route('ai.destroy', $request->id) }}" method="POST" onsubmit="return confirm('Вы уверены, что хотите удалить этот запрос?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white text-xs font-medium px-3 py-1.5 rounded transition duration-200" title="Удалить запрос">
                                                    🗑️ Удалить
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <p class="text-sm font-semibold text-gray-600 mb-1">Ваш запрос:</p>
                                        <p class="text-gray-900 bg-gray-50 p-3 rounded">{{ $request->prompt_text }}</p>
                                    </div>
                                    @if($request->response_text)
                                        <div>
                                            <p class="text-sm font-semibold text-gray-600 mb-1">Ответ AI:</p>
                                            <p class="text-gray-900 bg-blue-50 p-3 rounded whitespace-pre-wrap">{{ $request->response_text }}</p>
                                        </div>
                                    @endif
                                    @if($request->tokens_used)
                                        <p class="text-xs text-gray-500 mt-2">Использовано токенов: {{ $request->tokens_used }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-500 mb-4">У вас пока нет запросов к AI.</p>
                            <a href="{{ route('ai.index') }}" class="inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                                Создать первый запрос
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>