@props(['user'])

<div class="flex items-center gap-2 hover:scale-105 duration-300 cursor-pointer">

    <img alt="عکس {{$user->name}}" loading="lazy" class="rounded-full" src="{{$user->thumb_url}}">

    <div class="flex flex-col">
        <span class="text-sm font-black">{{$user->username}}</span>
        <span class="text-sm text-gray-600">{{$user->name}}</span>
    </div>
</div>