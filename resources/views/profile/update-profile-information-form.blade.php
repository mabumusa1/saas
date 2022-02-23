<x-jet-form-section submit="updateProfileInformation">
    <x-slot name="title">
        {{ __('Profile Information') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Update your account\'s profile information and email address.') }}
    </x-slot>

    <x-slot name="form">

        <x-jet-action-message on="saved">
            {{ __('Saved.') }}
        </x-jet-action-message>

        <!-- Profile Photo -->
        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
            <div class="form-group" x-data="{photoName: null, photoPreview: null}">
                <!-- Profile Photo File Input -->
                <input type="file" hidden
                       wire:model="photo"
                       x-ref="photo"
                       x-on:change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        photoPreview = e.target.result;
                                    };
                                    reader.readAsDataURL($refs.photo.files[0]);
                            " />

                <x-jet-label for="photo" value="{{ __('Photo') }}" />

                <!-- Current Profile Photo -->
                <div class="mt-2" x-show="! photoPreview">
                    <img src="{{ $this->user->profile_photo_url }}" class="rounded-circle" height="80px" width="80px">
                </div>

                <!-- New Profile Photo Preview -->
                <div class="mt-2" x-show="photoPreview">
                    <img x-bind:src="photoPreview" class="rounded-circle" width="80px" height="80px">
                </div>

                <x-jet-secondary-button class="mt-2 mr-2" type="button" x-on:click.prevent="$refs.photo.click()">
                    {{ __('Select A New Photo') }}
				</x-jet-secondary-button>
				
				@if ($this->user->profile_photo_path)
                    <x-jet-secondary-button type="button" class="mt-2" wire:click="deleteProfilePhoto">
                        {{ __('Remove Photo') }}
                    </x-jet-secondary-button>
                @endif

                <x-jet-input-error for="photo" class="mt-2" />
            </div>
        @endif

        <div class="w-md-75">
        <!-- First name -->
        <div class="col-span-6 sm:col-span-4">

            <!-- First Name -->
            <div class="form-group">
                <x-jet-label for="first_name" value="{{ __('First Name') }}" />
                <x-jet-input id="first_name" type="text" class="{{ $errors->has('first_name') ? 'is-invalid' : '' }}" wire:model.defer="state.first_name" autocomplete="first_name" />
                <x-jet-input-error for="name" />
            </div>
            <!-- Last Name -->
            <div class="form-group">
                <x-jet-label for="last_name" value="{{ __('Last Name') }}" />
                <x-jet-input id="last_name" type="text" class="{{ $errors->has('last_name') ? 'is-invalid' : '' }}" wire:model.defer="state.last_name" autocomplete="last_name" />
                <x-jet-input-error for="name" />
            </div>

            <!-- Email -->
            <div class="form-group">
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" type="email" class="{{ $errors->has('email') ? 'is-invalid' : '' }}" wire:model.defer="state.email" />
                <x-jet-input-error for="email" />
            </div>

            <!-- Phone -->
            <div class="form-group">
                <x-jet-label for="phone" value="{{ __('Phone') }}" />
                <x-jet-input id="phone" type="text" class="{{ $errors->has('phone') ? 'is-invalid' : '' }}" wire:model.defer="state.phone" autocomplete="phone" />
                <x-jet-input-error for="phone" />
            </div>            

            <!-- Job Title -->
            <div class="form-group">
                <x-jet-label for="job_title" value="{{ __('Job Title') }}" />
                <select wire:model.defer="state.job_title" name="job_title" id="job_title" class="form-control">
                    <?php
                        $titles = ['Developer', 'Marketer', 'Designer', 'Project Manager', 'Billing Manager', 'IT Professional', 'Executive', 'None of these'];
                    ?>
                    @foreach ($titles as $title )
                        <option value="{{ $title }}">{{ $title }}</option>    
                    @endforeach
                </select>
                <x-jet-input-error for="job_title" class="mt-2" />                
            </div>

            <!-- Employer -->
            <div class="form-group">
                <x-jet-label for="employer" value="{{ __('Employer') }}" />
                <select wire:model.defer="state.employer" name="employer" id="employer" class="form-control">
                    <?php
                        $employers = ['Myself, freelance', 'Myself, full-time', 'Agency', 'Business/In-house'];
                    ?>
                    @foreach ($employers as $employer )
                        <option value="{{ $employer }}">{{ $employer }}</option>    
                    @endforeach
                </select>
                <x-jet-input-error for="text" class="mt-2" />                
            </div>

            <!-- Experince -->
            <div class="form-group">
                <x-jet-label for="experince" value="{{ __('Experince') }}" />
                <select wire:model.defer="state.experince" name="experince" id="experince" class="form-control">
                    <?php
                        $experinces = ['I am a beginner', 'I have some experience', 'I feel comfortable with most Mautic-related tasks', 'I am an expert'];
                    ?>
                    @foreach ($experinces as $experince )
                        <option value="{{ $experince }}">{{ $experince }}</option>    
                    @endforeach
                </select>
                <x-jet-input-error for="text" class="mt-2" />                
            </div>

            <!-- Company Name -->
            <div class="form-group">
                <x-jet-label for="company_name" value="{{ __('Company Name') }}" />
                <x-jet-input id="company_name" type="text" class="{{ $errors->has('company_name') ? 'is-invalid' : '' }}" wire:model.defer="state.company_name" autocomplete="company_name" />
                <x-jet-input-error for="name" />
            </div>
        </div>
    </x-slot>

    <x-slot name="actions">
		<div class="d-flex align-items-baseline">
			<x-jet-button>
				{{ __('Save') }}
			</x-jet-button>
		</div>
    </x-slot>
</x-jet-form-section>