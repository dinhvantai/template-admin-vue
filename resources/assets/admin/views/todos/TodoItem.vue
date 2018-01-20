<template>
    <li class="todo" :class="{ completed: todo.done, editing: editing }">
        <div class="view">
            <input
                class="toggle"
                type="checkbox"
                :checked="todo.done"
                @change="toggleTodo(todo)"
            />
            <label v-text="todo.text" @dblclick="editing = true"></label>
            <i class="icon-trash icon" @click="deleteTodo(todo)"></i>
        </div>
        <input
            class="edit"
            v-show="editing"
            v-focus="editing"
            :value="todo.text"
            @keyup.enter="doneEdit"
            @keyup.esc="cancelEdit"
            @blur="doneEdit"
        />
    </li>
</template>

<script>
import { mapActions } from 'vuex'

export default {
    name: 'TodoItem',
    props: ['todo'],
    data() {
        return {
            editing: false
        }
    },
    directives: {
        focus (el, { value }, { context }) {
            if (value) {
                context.$nextTick(() => {
                    el.focus()
                })
            }
        }
    },
    methods: {
        ...mapActions([
            'editTodo',
            'toggleTodo',
            'deleteTodo'
            // TODO_EDIT,
            // TODO_TOGGLE,
            // TODO_DELETE
        ]),
        doneEdit(event) {
            const value = event.target.value.trim();
            const { todo } = this;

            if (!value) {
                this.deleteTodo(todo)
            } else if (this.editing) {
                this.editTodo({todo, value})
            }
            this.editing = false;
        },
        cancelEdit(event) {
            event.target.value = this.todo.text;
            this.editing = false;
        }
    }
}
</script>

<style scoped>
    .todo {
        display: block
    }
</style>
