@php
    $inputId = $inputId ?? 'password';
@endphp

<div class="mt-2 text-xs text-slate-500" data-password-requirements data-password-input="{{ $inputId }}">
    <p class="font-medium text-slate-600">Password must include:</p>
    <ul class="mt-1 space-y-1">
        <li data-rule="min">At least 8 characters</li>
        <li data-rule="lower">One lowercase letter</li>
        <li data-rule="upper">One uppercase letter</li>
        <li data-rule="number">One number</li>
        <li data-rule="symbol">One special character</li>
    </ul>
</div>

<script>
    (function () {
        if (window.__passwordRequirementsInit) return;
        window.__passwordRequirementsInit = true;

        const init = () => {
            document.querySelectorAll('[data-password-requirements]').forEach((block) => {
                const inputId = block.dataset.passwordInput;
                const input = document.getElementById(inputId);
                if (!input) return;

                const rules = {
                    min: (value) => value.length >= 8,
                    lower: (value) => /[a-z]/.test(value),
                    upper: (value) => /[A-Z]/.test(value),
                    number: (value) => /\\d/.test(value),
                    symbol: (value) => /[^A-Za-z0-9]/.test(value),
                };

                const update = () => {
                    const value = input.value || '';
                    block.querySelectorAll('[data-rule]').forEach((item) => {
                        const rule = item.dataset.rule;
                        const met = rules[rule] ? rules[rule](value) : false;
                        item.classList.toggle('text-emerald-600', met);
                        item.classList.toggle('text-slate-500', !met);
                    });
                };

                input.addEventListener('input', update);
                update();
            });
        };

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', init);
        } else {
            init();
        }
    })();
</script>
