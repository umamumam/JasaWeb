<script setup lang="ts">
</script>

<template>
    <div class="flex items-center gap-2.5">
        <div class="relative flex h-8 w-8 shrink-0 items-center justify-center">
            <div
                class="absolute inset-0 rounded-xl bg-brand-orange/15 opacity-80 blur-[2px] transition duration-300 group-hover:scale-110"
            ></div>
            <div
                class="relative flex h-7 w-7 items-center justify-center rounded-lg border border-orange-200/60 bg-white/70 text-brand-orange shadow-sm dark:border-orange-500/20 dark:bg-slate-900/60"
            >
                <svg
                    class="h-3.5 w-3.5"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="3"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                >
                    <polyline points="16 18 22 12 16 6" />
                    <polyline points="8 6 2 12 8 18" />
                </svg>
            </div>
        </div>
        <span
            class="font-sans text-base font-extrabold tracking-tight text-slate-900 dark:text-white"
        >
            Jasa<span class="text-brand-orange">Web</span><span class="text-brand-orange font-black">.</span>
        </span>
    </div>
</template>
