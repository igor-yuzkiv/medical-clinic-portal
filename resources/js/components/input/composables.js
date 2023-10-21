
export const componentProps = {
    color     : {
        type   : String,
        default: 'default',
        validate(value) {
            return ['default', 'primary', 'success', 'indigo'].includes(value);
        }
    },
    size      : {
        type   : String,
        default: 'md',
        validate(value) {
            return ['sm', 'md', 'lg', 'xl'].includes(value);
        }
    },
}

export const borderColorVariants = {
    default: 'border-gray-400',
    primary: 'border-blue-400',
    success: 'border-green-400',
    indigo : 'border-indigo-400',
}

export const placeHolderColorVariants = {
    default: 'placeholder-gray-500',
    primary: 'placeholder-blue-800/70',
    success: 'placeholder-green-800/70',
    indigo : 'placeholder-indigo-800/50',
}

export const bgColorVariants = {
    default: 'bg-gray-100',
    primary: 'bg-blue-100',
    success: 'bg-green-100',
    indigo : 'bg-indigo-100',
}

export const textColorVariants = {
    default: 'text-black',
    primary: 'text-blue-700',
    success: 'text-green-700',
    indigo : 'text-indigo-700',
}

export const textSizeVariants = {
    sm: 'text-sm',
    md: 'text-base',
    lg: 'text-lg',
    xl: 'text-xl',
}
