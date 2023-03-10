<div>
    <div class="block xl:grid grid-cols-2 gap-4">
        <div class="hidden xl:flex flex-col min-h-screen">
            <a href="/" class="-intro-x flex items-center pt-5">
                <img alt="23" class="w-6" src="/dist/images/logo.png">
                <span class="text-white text-lg ml-3"> DCC<span class="font-medium">23</span> </span>
            </a>
            <div class="my-auto">
                <img alt="DCC23" class="-intro-x w-1/2 -mt-16" src="/dist/images/illustration.svg">
                <div class="-intro-x text-white font-medium text-4xl leading-tight mt-10">
                    A few more clicks to
                    <br>
                    sign in to your account.
                </div>
            </div>
        </div>
        <div class="h-screen xl:h-auto flex py-5 xl:py-0 my-10 xl:my-0">
            <div
                class="my-auto mx-auto xl:ml-20 bg-white dark:bg-dark-1 xl:bg-transparent px-5 sm:px-8 py-8 xl:p-0 rounded-md shadow-md xl:shadow-none w-full sm:w-3/4 lg:w-2/4 xl:w-auto">
                <h2 class="intro-x font-bold text-2xl xl:text-3xl text-center xl:text-left">
                    Sign In
                </h2>
                <div class="intro-x mt-2 text-gray-500 xl:hidden text-center">A few more clicks to sign in to your
                    account.
                    Manage all your accounts in one place</div>
                <form wire:submit.prevent="submit">
                    <div class="intro-x mt-8">
                        <input type="text" class="intro-x login__input form-control py-3 px-4 border-gray-300 block"
                            wire:model.defer="username" placeholder="Username" autocomplete="off">
                        <div class="input-group">
                            <input type="password"
                                class="intro-x login__input form-control py-3 px-4 border-gray-300  mt-4"
                                wire:model.defer="password" id="myInput" placeholder="Password" autocomplete="off">
                        </div>
                    </div>
                    <div class="intro-x flex text-gray-700 dark:text-gray-600 text-xs sm:text-sm mt-4">
                        <div class="flex items-center mr-auto">
                            <input id="remember-me" type="checkbox" onclick="myFunction()"
                                class="form-check-input border mr-2">
                            <label class="cursor-pointer select-none" for="remember-me">Show Password</label>
                        </div>
                    </div>
                    <div class="intro-x mt-5 xl:mt-8 text-center xl:text-left">
                        <button type="submit"
                            class="btn btn-primary py-3 px-4 w-full xl:w-32 xl:mr-3 align-top">Login</button>
                    </div>
                </form>
                <br>
                <x-alert />
                <x-info />
            </div>
        </div>
    </div>
    <script>
        function myFunction() {
            var x = document.getElementById("myInput");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>
</div>
