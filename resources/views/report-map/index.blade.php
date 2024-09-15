<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('報告マップ') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <div class="flex">
                        <!-- Google Map -->
                        <div id="map" class="w-2/3 h-96"></div>

                        <!-- 報告一覧 -->
                        <div class="w-1/3 ml-4 overflow-y-auto h-96">
                            <h3 class="text-lg font-semibold mb-4">報告一覧</h3>
                            <ul class="space-y-2">
                                @foreach ($reports as $report)
                                <li class="border-b pb-2 cursor-pointer hover:bg-gray-100" onclick="showReportLocation({{ $report->latitude ?? 0 }}, {{ $report->longitude ?? 0 }}, '{{ addslashes($report->user->name) }}')">
                                    <p class="font-semibold">{{ $report->user->name }}</p>
                                    <p class="text-sm text-gray-600">{{ $report->created_at->format('Y-m-d H:i') }}</p>
                                </li>
                                @endforeach
                            </ul>
                            <button onclick="plotAllReports()" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded">すべての報告をプロット</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        (g=>{var h,a,k,p="The Google Maps JavaScript API",c="google",l="importLibrary",q="__ib__",m=document,b=window;b=b[c]||(b[c]={});var d=b.maps||(b.maps={}),r=new Set,e=new URLSearchParams,u=()=>h||(h=new Promise(async(f,n)=>{await (a=m.createElement("script"));e.set("libraries",[...r]+"");for(k in g)e.set(k.replace(/[A-Z]/g,t=>"_"+t[0].toLowerCase()),g[k]);e.set("callback",c+".maps."+q);a.src=`https://maps.${c}apis.com/maps/api/js?`+e;d[q]=f;a.onerror=()=>h=n(Error(p+" could not load."));a.nonce=m.querySelector("script[nonce]")?.nonce||"";m.head.append(a)}));d[l]?console.warn(p+" only loads once. Ignoring:",g):d[l]=(f,...n)=>r.add(f)&&u().then(()=>d[l](f,...n))})({
            key: "{{ config('services.google.maps_api_key') }}",
            v: "weekly"
        });
    </script>
    <script>
        let map;
        let currentMarker;

        async function initMap() {
            const { Map } = await google.maps.importLibrary("maps");

            map = new Map(document.getElementById("map"), {
                center: { lat: 35.6812, lng: 139.7671 }, // 東京の座標
                zoom: 8,
            });
        }

        async function showReportLocation(lat, lng, reporterName) {
            const { Marker } = await google.maps.importLibrary("marker");

            const position = { lat: lat, lng: lng };
            map.setCenter(position);
            map.setZoom(15);

            if (currentMarker) {
                currentMarker.setMap(null);
            }

            currentMarker = new Marker({
                map: map,
                position: position,
                title: reporterName
            });
        }

        initMap();
    </script>
</x-app-layout>
