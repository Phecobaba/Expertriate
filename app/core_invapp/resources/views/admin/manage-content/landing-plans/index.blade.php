@extends('admin.layouts.master')
@section('title', __('Landing Plans'))

@section('content')
    <div class="nk-content-body">
        <div class="nk-block-head nk-block-head-sm">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h3 class="nk-block-title page-title">{{ __('Landing Plans') }}</h3>
                    <p>{{ __('Manage only the landing page investment plan cards.') }}</p>
                </div>
            </div>
        </div>

        <div class="nk-block">
            <div class="card card-bordered">
                <div class="card-inner">
                    <h5 class="title mb-3">{{ __('Add New Plan') }}</h5>
                    <form action="{{ route('admin.manage.landing.plans.save') }}" method="POST" class="form-validate is-alter">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">{{ __('Plan Name') }}</label>
                                    <input type="text" class="form-control" name="name" required>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="form-label">{{ __('Return Rate') }}</label>
                                    <input type="text" class="form-control" name="return_rate" placeholder="30%" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label">{{ __('Return Duration') }}</label>
                                    <input type="text" class="form-control" name="return_duration" placeholder="after 48hours" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label">{{ __('Badge Text') }}</label>
                                    <input type="text" class="form-control" name="badge_text" value="24/7 support">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label">{{ __('Min Amount') }}</label>
                                    <input type="number" step="0.01" min="0" class="form-control" name="min_amount" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label">{{ __('Max Amount (optional)') }}</label>
                                    <input type="number" step="0.01" min="0" class="form-control" name="max_amount">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="form-label">{{ __('Sort') }}</label>
                                    <input type="number" class="form-control" name="sort_order" value="0">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="form-label">{{ __('CTA Text') }}</label>
                                    <input type="text" class="form-control" name="cta_text" value="Purchase Plan">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="form-label">{{ __('CTA URL') }}</label>
                                    <input type="text" class="form-control" name="cta_url" value="/app/register">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">{{ __('Features (One per line)') }}</label>
                                    <textarea name="features" rows="5" class="form-control" placeholder="Active Support&#10;Fast Payouts&#10;Instant withdrawal"></textarea>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="new_recommended" name="is_recommended" value="1">
                                    <label class="custom-control-label" for="new_recommended">{{ __('Recommended') }}</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="new_active" name="is_active" value="1" checked>
                                    <label class="custom-control-label" for="new_active">{{ __('Active') }}</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">{{ __('Create Plan') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="nk-block">
            @foreach($plans as $plan)
            <div class="card card-bordered mb-4">
                <div class="card-inner">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="title mb-0">{{ $plan->name }}</h6>
                        <form action="{{ route('admin.manage.landing.plans.delete', $plan->id) }}" method="POST" onsubmit="return confirm('{{ __('Delete this plan?') }}')">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-danger">{{ __('Delete') }}</button>
                        </form>
                    </div>
                    <form action="{{ route('admin.manage.landing.plans.save') }}" method="POST" class="form-validate is-alter">
                        @csrf
                        <input type="hidden" name="id" value="{{ $plan->id }}">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">{{ __('Plan Name') }}</label>
                                    <input type="text" class="form-control" name="name" value="{{ $plan->name }}" required>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="form-label">{{ __('Return Rate') }}</label>
                                    <input type="text" class="form-control" name="return_rate" value="{{ $plan->return_rate }}" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label">{{ __('Return Duration') }}</label>
                                    <input type="text" class="form-control" name="return_duration" value="{{ $plan->return_duration }}" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label">{{ __('Badge Text') }}</label>
                                    <input type="text" class="form-control" name="badge_text" value="{{ $plan->badge_text }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label">{{ __('Min Amount') }}</label>
                                    <input type="number" step="0.01" min="0" class="form-control" name="min_amount" value="{{ $plan->min_amount }}" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label">{{ __('Max Amount (optional)') }}</label>
                                    <input type="number" step="0.01" min="0" class="form-control" name="max_amount" value="{{ $plan->max_amount }}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="form-label">{{ __('Sort') }}</label>
                                    <input type="number" class="form-control" name="sort_order" value="{{ $plan->sort_order }}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="form-label">{{ __('CTA Text') }}</label>
                                    <input type="text" class="form-control" name="cta_text" value="{{ $plan->cta_text }}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="form-label">{{ __('CTA URL') }}</label>
                                    <input type="text" class="form-control" name="cta_url" value="{{ $plan->cta_url }}">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">{{ __('Features (One per line)') }}</label>
                                    <textarea name="features" rows="5" class="form-control">{{ implode("\n", $plan->features ?? []) }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="recommended_{{ $plan->id }}" name="is_recommended" value="1"{{ $plan->is_recommended ? ' checked' : '' }}>
                                    <label class="custom-control-label" for="recommended_{{ $plan->id }}">{{ __('Recommended') }}</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="active_{{ $plan->id }}" name="is_active" value="1"{{ $plan->is_active ? ' checked' : '' }}>
                                    <label class="custom-control-label" for="active_{{ $plan->id }}">{{ __('Active') }}</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">{{ __('Update Plan') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </div>
@endsection

