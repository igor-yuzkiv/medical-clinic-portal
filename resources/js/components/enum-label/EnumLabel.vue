<script>
import {computed, defineComponent, h} from "vue";
import {Badge} from "flowbite-vue";

export default defineComponent({
    props: {
        value: {
            type: [String, Number]
        },
        options:{
            type: Array,
            default: () => []
        }
    },
    setup(props) {
        const label = computed(() => {
            const item = props.options.find(item => item.value === props.value)
            if (item) {
                return item.name
            }
            return ''
        })

        return () => h(Badge, {type: 'green', class: 'inline-flex'}, () => [label.value])
    }
})
</script>
