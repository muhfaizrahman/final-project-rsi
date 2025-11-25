<!DOCTYPE html>
<html lang="en">
@include('components.head')
<body class="min-h-screen flex items-center justify-center">

    @if (session('success')) 
        <p>{{ session('success') }}</p>
    @endif

    @if ($errors->any()) 
        <p>{{ $errors->first() }}</p>    
    @endif
    
    <main class="flex w-full max-w-5xl justify-center items-center space-x-16">
        
        <h1 class="text-3xl font-bold text-black">
            Find your career. Claim your equality
        </h1>

        <div class="bg-white shadow-2xl rounded-3xl">

            <div class="w-[600px] p-12 flex flex-col justify-center">
                
                <h2 class="text-3xl font-bold mb-10 text-black">Sign Up as A Company</h2>
                {{-- Main Form --}}
                <form action="{{ route('') }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label for="email" class="block text-sm font-medium text-black mb-1">Email</label>
                        <input type="email" id="email" name="email" placeholder="" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-full bg-gray-100 focus:ring-[#7E794B] focus:border-[#7E794B] transition duration-150"
                            required>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-black mb-1">Password</label>
                        <input type="password" id="password" name="password" placeholder="" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-full bg-gray-100 focus:ring-[#7E794B] focus:border-[#7E794B] transition duration-150"
                            required>
                    </div>
                    
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-black mb-1">Repeat Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-full bg-gray-100 focus:ring-[#7E794B] focus:border-[#7E794B] transition duration-150"
                            required>
                    </div>
                    
                    <div class="flex items-center">
                        <input id="remember-me" name="remember-me" type="checkbox" 
                            class="h-4 w-4 text-[#7E794B] border-gray-300 rounded focus:ring-[#7E794B]">
                        <label for="remember-me" class="ml-2 block text-sm text-black font-bold">Remember Me</label>
                    </div>
                    
                    <div class="py-2"></div>
                    
                    <div>
                        <button type="submit" 
                                class="w-full flex justify-center py-3 px-4 border border-transparent rounded-full shadow-sm text-lg font-bold text-white bg-[#7E794B] hover:bg-[#6B6840] hover:bg-opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#6B6840] transition duration-150 cursor-pointer">
                            Sign Up
                        </button>
                    </div>
                </form>

                <div class="text-center mt-12 text-sm">
                    <span class="text-black font-bold">Already have account? </span>
                    <a href="{{ route('') }}" class="text-[#180081] font-bold hover:text-[#120064] hover:underline">Sign In</a>
                </div>
                
            </div>
        </div>
    </main>

</body>
</html>