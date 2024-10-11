<x-layout>
    <h1 class="title">Welcome back!</h1>
    <div class="mx-auto max-w-screen-sm card">
        <form action="{{ route('login') }}" method="post">
            @csrf
            {{-- email --}}
            <div class="mb-4">
                <label for="email">Email</label>
                <input type="text" name="email" value="{{ old('email') }}"
                    class="input @error('email') ring-rose-500  @enderror">

                @error('email') 
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>
            {{-- password --}}
            <div class="mb-4">
                <label for="password">Password</label>
                <input type="password" name="password" 
                    class="input @error('password') ring-rose-500  @enderror">

                @error('password') 
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>  
            {{-- remember me --}}
            <div class="mb-4 flex">
                <input type="checkbox" name="remember" id="remember"/>
                <label for="remember" class="ps-2">Remember me</label>

            </div>
            @error('failed') 
                <p class="error flex-auto mb-4">{{ $message }}</p>
            @enderror

            {{-- button --}}
            <button class="text-white bg-gradient-to-br from-purple-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                Login
            </button>
        </form>
    </div>
</x-layout>