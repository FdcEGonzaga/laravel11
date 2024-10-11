<x-layout>
    <h1 class="title">Register an account</h1>
    <div class="mx-auto max-w-screen-sm card">
        <form action="{{ route('register') }}" method="post">
            @csrf
            {{-- userName --}}
            <div class="mb-4">
                <label for="user_name">Username</label>
                <input type="text" name="user_name" value="{{ old('user_name') }}"
                    class="input @error('user_name') ring-rose-500 @enderror">

                @error('user_name')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>
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
            {{-- confirm password --}}
            <div class="mb-4">
                <label for="password_confirmation">Confirm password</label>
                <input type="password" name="password_confirmation" 
                    class="input @error('password') ring-rose-500  @enderror">
            </div>
            {{-- button --}}
            <button class="text-white bg-gradient-to-br from-purple-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                Register
            </button>
        </form>
    </div>
</x-layout>