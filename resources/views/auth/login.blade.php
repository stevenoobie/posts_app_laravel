<x-form>
    <div class="text-xl text-left my-3 font-bold ">Sign in here</div>
   <form action="{{route('login')}}" method="post" class="flex flex-col gap-3 ">
        @csrf
        <input type="email" name="email" placeholder="test@test.com" class="p-4">
        <input type="password" name="password" placeholder="******" class="p-4">
        @if ($errors->has('email'))
        <div class="text-red-500 text-sm">{{ $errors->first('email') }}</div>
        @endif
        <button type="submit"  class="btn-primary">Login</button>
    </form> 

    <a href="{{route('register')}}">

        <button class="btn-secondary">
            Register
        </button>

    </a>



</x-form>