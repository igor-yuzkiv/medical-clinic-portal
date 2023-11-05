<script setup>
defineProps({
    square: {
        type   : Boolean,
        default: true,
    },
    circle: {
        type   : Boolean,
        default: false,
    },
    image: {
        type   : String,
        default: "",
    },
    size  : {
        type   : String,
        default: 'md',
        validator(value) {
            return ['md', 'lg', 'xl', '2xl'].includes(value);
        }
    }
})

const sizeVariants = {
    md: "text-md w-8 h-8",
    lg: "text-lg w-10 h-10",
    xl: "text-xl w-14 h-14",
    "2xl": "text-2xl w-24 h-24",
};

</script>

<template>
    <div
        class="inline-flex shrink-0 grow-0 text-white items-center justify-center font-semibold shadow-md"
        :class="{
            'rounded-full' : circle,
            'rounded-lg' : square  && !circle,
            [sizeVariants[size ?? 'md']]: true,
            'bg-gradient-to-tl from-indigo-400 via-indigo-500 to-indigo-600': !image,
        }"
    >
        <slot>
            <img
                v-if="image"
                alt="avatar"
                :src="image"
                class="object-cover"
                :class="{
                    'rounded-full' : circle,
                    'rounded-lg' : square  && !circle,
                    [sizeVariants[size ?? 'md']]: true,
                }"
            />
        </slot>
    </div>
</template>

<style scoped>

</style>
