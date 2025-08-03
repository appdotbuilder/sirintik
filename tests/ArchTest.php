<?php

test('models can be instantiated', function () {
    expect(\App\Models\User::class)->toBeClasses();
    expect(\App\Models\ReportCategory::class)->toBeClasses();
    expect(\App\Models\Report::class)->toBeClasses();
    expect(\App\Models\ReportTemplateField::class)->toBeClasses();
    expect(\App\Models\PublicSummary::class)->toBeClasses();
});