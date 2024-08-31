<x-app-layout>
    <x-slot name="header">
        <h2 style="text-align: center; font-size: 24px; color: #333;">
            {{ __('Gair ai') }}
        </h2>
    </x-slot>

    <div style="display: flex; justify-content: center; align-items: center; min-height: 80vh;">
        <div>
            <h2 style="text-align: center; font-size: 20px; color: #333; margin-bottom: 30px;">ようこそ、{{ Auth::user()->name }}さん</h2>
            
            <div style="display: flex; flex-direction: column; align-items: center;">
                <a href="{{ route('report.create') }}" style="display: inline-block; padding: 12px 24px; background-color: #4CAF50; color: white; text-decoration: none; margin-bottom: 20px; text-align: center; width: 150px; border-radius: 25px; font-weight: bold; transition: all 0.3s ease; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                    新規報告
                </a>
                <a href="{{ route('report.index') }}" style="display: inline-block; padding: 12px 24px; background-color: #2196F3; color: white; text-decoration: none; text-align: center; width: 150px; border-radius: 25px; font-weight: bold; transition: all 0.3s ease; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                    報告一覧
                </a>
            </div>
        </div>
    </div>
    
</x-app-layout>