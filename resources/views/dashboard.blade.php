<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- AI Assistant Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <div class="text-4xl mr-3">🤖</div>
                            <h3 class="text-xl font-semibold text-gray-900">AI Помощник</h3>
                        </div>
                        <p class="text-gray-600 mb-4">
                            Используйте AI для генерации текстов, идей и ответов на ваши вопросы.
                        </p>
                        <a href="{{ route('ai.index') }}" class="inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                            Создать запрос →
                        </a>
                    </div>
                </div>

                <!-- History Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <div class="text-4xl mr-3">📋</div>
                            <h3 class="text-xl font-semibold text-gray-900">История запросов</h3>
                        </div>
                        <p class="text-gray-600 mb-4">
                            Просматривайте все ваши предыдущие запросы к AI и их ответы.
                        </p>
                        <a href="{{ route('ai.history') }}" class="inline-block bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">
                            Открыть историю →
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
