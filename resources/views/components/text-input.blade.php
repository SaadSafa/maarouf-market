@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 text-emerald-900 placeholder-emerald-400 dark:border-gray-700 dark:bg-gray-900 dark:text-emerald-100 dark:placeholder-emerald-400 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm']) }}>
