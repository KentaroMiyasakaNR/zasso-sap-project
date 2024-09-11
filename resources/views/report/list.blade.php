<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('報告一覧') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 grid grid-cols-2 gap-4">
                    @foreach ($reports as $report)
                        <div class="border rounded-lg p-4">
                            <div class="mb-2">
                                <strong>報告者：</strong> {{ $report->user->name }}
                            </div>
                            <div class="mb-2">
                                <strong>報告日時：</strong> {{ $report->created_at->format('Y年m月d日 H:i') }}
                            </div>
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $report->photo_path) }}" alt="報告写真" class="w-full h-48 object-cover rounded">
                            </div>
                            <div>
                                <strong>報告内容：</strong> {{ $report->identification_result }}
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4 p-4">
                    {{ $reports->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
