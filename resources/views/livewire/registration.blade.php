<div>
    <div class="block xl:grid grid-cols-2 gap-4">
        <div class="hidden xl:flex flex-col min-h-screen">
            <a href="/" class="-intro-x flex items-center pt-5">
                <img alt="Icewall Tailwind HTML Admin Template" class="w-6" src="/dist/images/logo.png">
                <span class="text-white text-lg ml-3"> Ice<span class="font-medium">wall</span> </span>
            </a>
            <div class="my-auto">
                <img alt="Icewall Tailwind HTML Admin Template" class="-intro-x w-1/2 -mt-16"
                    src="/dist/images/illustration.svg">
                <div class="-intro-x text-white font-medium text-4xl leading-tight mt-10">
                    A few more clicks to
                    <br>
                    sign up to your account.
                </div>
                <div class="-intro-x mt-5 text-lg text-white text-opacity-70 dark:text-gray-500">Manage all your
                    e-commerce accounts in one place</div>
            </div>
        </div>
        <div class="h-screen xl:h-auto flex py-5 xl:py-0 my-10 xl:my-0">
            <div
                class="my-auto mx-auto xl:ml-20 bg-white dark:bg-dark-1 xl:bg-transparent px-5 sm:px-8 py-8 xl:p-0 rounded-md shadow-md xl:shadow-none w-full sm:w-3/4 lg:w-2/4 xl:w-auto">
                <h2 class="intro-x font-bold text-2xl xl:text-3xl text-center xl:text-left">
                    Sign In
                </h2>
                <div class="intro-x mt-2 text-gray-500 xl:hidden text-center">A few more clicks to
                    sign in to your account. Manage all your e-commerce accounts in one place</div>
                <form wire:submit.prevent="submit">
                    <div class="intro-x mt-8">
                        <input type="text" class="intro-x login__input form-control py-3 px-4 border-gray-300 block"
                            placeholder="Username" wire:model.defer="username">
                        <input type="text"
                            class="intro-x login__input form-control py-3 px-4 border-gray-300 block mt-4"
                            placeholder="Name" wire:model.defer="name">
                        <input type="text"
                            class="intro-x login__input form-control py-3 px-4 border-gray-300 block mt-4"
                            placeholder="Phone" wire:model.defer="phone">
                        <input type="email"
                            class="intro-x login__input form-control py-3 px-4 border-gray-300 block mt-4"
                            placeholder="Email" wire:model.defer="email">
                        <input type="password"
                            class="intro-x login__input form-control py-3 px-4 border-gray-300 block mt-4"
                            placeholder="Password" wire:model.defer="password">
                        <select class="form-select mt-2 sm:mr-2 mt-4" wire:model.defer="package"
                            aria-label="Default select example">
                            <option selected hidden>-- Select Package --</option>
                            @foreach (\App\Models\Package::all() as $row)
                                <option value="{{ $row->value }}">{{ number_format($row->value) }}</option>
                            @endforeach
                        </select>
                    </div>
                    {{-- <div class="intro-x flex items-center text-gray-700 dark:text-gray-600 mt-4 text-xs sm:text-sm">
                        <input id="remember-me" type="checkbox" class="form-check-input border mr-2">
                        <label class="cursor-pointer select-none" for="remember-me">I agree to the Envato</label>
                        <a class="text-theme-17 dark:text-gray-300 ml-1" href="">Privacy Policy</a>.
                    </div> --}}
                    <div class="intro-x mt-5 xl:mt-8 text-center xl:text-left">
                        <button type="submit"
                            class="btn btn-primary py-3 px-4 w-full xl:w-32 xl:mr-3 align-top">Register</button>
                        <a href="/login"
                            class="btn btn-outline-secondary py-3 px-4 w-full xl:w-32 mt-3 xl:mt-0 align-top">Sign
                            in</a>
                    </div>
                </form>
                <br>
                <x-alert />
                <x-info />
            </div>
        </div>
    </div>
</div>
