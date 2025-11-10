<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            🤖 AI Помощник
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Создать новый запрос к AI</h3>
                    
                    <form action="{{ route('ai.process') }}" method="POST">
                        @csrf
                        
                        <div class="mb-6">
                            <label for="prompt" class="block text-sm font-medium text-gray-700 mb-2">
                                Ваш запрос:
                            </label>
                            <textarea 
                                id="prompt" 
                                name="prompt" 
                                rows="6" 
                                class="border border-gray-300 rounded-lg p-3 w-full focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                                placeholder="Например: Напиши краткую статью о преимуществах использования искусственного интеллекта в бизнесе..."
                                required
                            >{{ old('prompt') }}</textarea>
                            <p class="mt-1 text-sm text-gray-500">Максимум 1000 символов</p>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <a href="{{ route('ai.history') }}" class="text-gray-600 hover:text-gray-900">
                                ← Посмотреть историю
                            </a>
                            <button 
                                type="submit" 
                                class="bg-blue-500 hover:bg-blue-600 text-white font-medium px-6 py-2 rounded-lg transition duration-200"
                            >
                                🚀 Отправить запрос
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                <h4 class="font-semibold text-blue-900 mb-2">💡 Примеры запросов:</h4>
                <ul class="text-sm text-blue-800 space-y-1 list-disc list-inside">
                    <li>Напиши email для клиента о новой услуге</li>
                    <li>Придумай 5 идей для поста в соцсетях</li>
                    <li>Объясни простыми словами, что такое машинное обучение</li>
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>