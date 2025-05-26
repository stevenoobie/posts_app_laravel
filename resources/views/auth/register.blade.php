<x-form>
    <div class="text-xl text-left my-3 font-bold ">Sign up here</div>
   <form action="{{route('register')}}" method="post" class="flex flex-col gap-3 ">
        @csrf
        <input type="name" name="name" placeholder="John Doe" class="p-4">
        <input type="email" name="email" placeholder="test@test.com" class="p-4">
        <input type="password" name="password" placeholder="******" class="p-4">
        <input type="password" name="password_confirmation" placeholder="******" class="p-4">
        @if ($errors->has('email'))
        <div class="text-red-500 text-sm">{{ $errors->first('email') }}</div>
        @endif
        <button type="submit"  class="btn-primary">Register</button>
    </form> 
    <a href="{{route('login')}}">
        <button class="btn-secondary">
            Login
        </button>
    
    </a>
  


</x-form>