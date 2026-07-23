@php
    use App\Models\Service;

    $modalServices = Service::query()->published()->get();
@endphp

<div
    class="service-request-overlay"
    data-service-request-overlay
    hidden
    aria-hidden="true"
></div>

<div
    id="service-request-modal"
    class="service-request-modal"
    data-service-request-modal
    data-submitting-label="{{ __('site.service_request.submitting') }}"
    data-error-label="{{ __('site.service_request.error') }}"
    role="dialog"
    aria-modal="true"
    aria-labelledby="service-request-title"
    hidden
    aria-hidden="true"
>
    <div class="service-request-dialog">
        <div class="service-request-head">
            <div>
                <h2 id="service-request-title" class="service-request-title">{{ __('site.service_request.title') }}</h2>
                <p class="service-request-lead">{{ __('site.service_request.lead') }}</p>
            </div>
            <button
                type="button"
                class="service-request-close"
                data-service-request-close
                aria-label="{{ __('site.service_request.close') }}"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div class="service-request-alert is-success" data-service-request-success hidden></div>
        <div class="service-request-alert is-error" data-service-request-error hidden></div>

        <form
            class="service-request-form"
            data-service-request-form
            action="{{ route('service-requests.store') }}"
            method="POST"
            novalidate
        >
            @csrf

            <div>
                <label for="service-request-name" class="field-label">{{ __('site.service_request.name') }}</label>
                <input
                    id="service-request-name"
                    name="name"
                    type="text"
                    required
                    class="field"
                    placeholder="{{ __('site.service_request.name_ph') }}"
                    autocomplete="name"
                >
                <p class="service-request-field-error" data-error-for="name" hidden></p>
            </div>

            <div>
                <label for="service-request-phone" class="field-label">{{ __('site.service_request.phone') }}</label>
                <input
                    id="service-request-phone"
                    name="phone"
                    type="tel"
                    required
                    class="field"
                    placeholder="{{ __('site.service_request.phone_ph') }}"
                    dir="ltr"
                    autocomplete="tel"
                >
                <p class="service-request-field-error" data-error-for="phone" hidden></p>
            </div>

            <div>
                <label for="service-request-email" class="field-label">{{ __('site.service_request.email') }}</label>
                <input
                    id="service-request-email"
                    name="email"
                    type="email"
                    required
                    class="field"
                    placeholder="{{ __('site.service_request.email_ph') }}"
                    dir="ltr"
                    autocomplete="email"
                >
                <p class="service-request-field-error" data-error-for="email" hidden></p>
            </div>

            <div>
                <label for="service-request-service" class="field-label">{{ __('site.service_request.service') }}</label>
                <select id="service-request-service" name="service_id" required class="field">
                    <option value="">{{ __('site.service_request.service_ph') }}</option>
                    @foreach ($modalServices as $service)
                        <option value="{{ $service->id }}">
                            {{ locale_text('site.services.items.'.$service->slug.'.title', $service->title) }}
                        </option>
                    @endforeach
                </select>
                <p class="service-request-field-error" data-error-for="service_id" hidden></p>
            </div>

            <button type="submit" class="btn-primary service-request-submit" data-service-request-submit>
                <span data-service-request-submit-label>{{ __('site.service_request.submit') }}</span>
            </button>
        </form>
    </div>
</div>
