<div class="grid grid-cols-5 gap-4">
    @include("sessions.session-input")
    <div class="col-span-3">
        <div class="grid grid-cols-2 gap-4">
            <div class="col-span-1 pt-4">
                <h2 class="font-normal text-2xl mb-4 text-siadi-blue-900 border-siadi-blue-300 border-b-2 w-max">Datos Usuario</h2>
                <h2><b>Nombres y Apellidos :</b> {{ $user->full_name }}</h2>
                <h2><b>Documento :</b> {{ $user->document }} </h2>
                <h2><b>Correo :</b> {{ $user->username }} </h2>
                <h2><b>Categoria :</b> {{ Auth::user()->department->name ?? 'No Categoria asociada' }}</h2>
                <h2><b>Estado :</b> {!! $user->state == 1 ? "<span class='text-green-600 font-bold'>Activo</span>" : "<span class='text-red-600 font-bold'>Desactivado</span>" !!} </h2>
                <h2><b>Cuenta verificada :</b> {!! $user->verified == 1 ? "<span class='text-green-500 font-bold'>Verificado</span>" : "<span class='text-red-500 font-bold'>No Verificado</span>" !!}</h2>
                <div class="border border-gray-300 w-max pl-2 hover:bg-blue-100 rounded-lg mb-4">
                    <span class="py-2 inline-block rounded-l-lg text-sm">
                        Creado en SIADI :</b> {{ \Illuminate\Support\Carbon::createFromFormat('Y-m-d H:i:s', $user->created_at)->format('d-m-Y') }}
                    </span>
                    <div class="bg-siadi-blue-900 text-gray-100 inline-block p-2 rounded-r-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
                <div class="border border-gray-300 w-max pl-2 hover:bg-blue-100 rounded-lg mb-4">
                    <span class="py-2 inline-block rounded-l-lg text-sm">
                        Fecha de verificación :</b> {{ $user->verified == 1 ? \Illuminate\Support\Carbon::createFromFormat('Y-m-d H:i:s', $user->email_verified_at)->format('d-m-Y') : "No hay registro" }}
                    </span>
                    <div class="bg-siadi-blue-900 text-gray-100 inline-block p-2 rounded-r-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
            </div>
            @if($profile)
                <div class="col-span-1 pt-4">
                    <h2 class="font-normal text-2xl mb-4 text-siadi-blue-900 border-siadi-blue-300 border-b-2 w-max">Acciones</h2>
                    <a wire:click="$toggle('change_password')"class="rounded-lg block mt-4 shadow-lg p-5 text-sm uppercase border-gray-300 border cursor-pointer w-max">
                        Cambiar contraseña
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-siadi-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </a>
                    <br />
                @if($change_password)
                        <div class="block">
                            <span class="text-gray-700 capitalize">{{ __('modules.user.password_current') }}</span>
                            <input type="text"
                                   class="@error('password_current') is-invalid-input @enderror input-underline"
                                   name="password_current" id="password_current" wire:model.defer="password_current" autocomplete="off">
                            @error('password_current')
                            <span class="form-error is-visible">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="block">
                            <span class="text-gray-700 capitalize">{{ __('modules.user.password_new') }}</span>
                            <input type="text"
                                   class="@error('password') is-invalid-input @enderror input-underline"
                                   name="password" id="password" wire:model.defer="password" autocomplete="off">
                            @error('password')
                            <span class="form-error is-visible">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="block">
                            <span class="text-gray-700 capitalize">{{ __('modules.user.password_confirm') }}</span>
                            <input type="text"
                                   class="@error('password_confirmation') is-invalid-input @enderror input-underline"
                                   name="password_confirmation" id="password_confirmation" wire:model.defer="password_confirmation" autocomplete="off">
                            @error('password_confirmation')
                                <span class="form-error is-visible">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="text-right my-4 flex flex-row-reverse">
                            <button class="btn btn-blue mr-0" wire:click="update">
                                <span>{{ __('modules.update') }}</span>
                            </button>
                            <button class="btn btn-red" wire:click="$toggle('change_password')">
                                <span>{{ __('modules.cancel') }}</span>
                            </button>
                        </div>
                @endif
            </div>
            @endif
        </div>
    </div>
</div>