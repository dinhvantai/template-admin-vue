<template>
    <section class="todoapp">
        <!-- header -->
        <header class="header">
            <h1>todos</h1>
            <input
                class="new-todo"
                autofocus
                autocomplete="off"
                placeholder="What needs to be done?"
                @keyup.enter="addTodo"
            />
        </header>
        <!-- main section -->
        <section class="main" v-show="todos.length">
            <b-form-checkbox
                class="toggle-all"
                id="toggle-all"
                type="checkbox"
                :checked="allChecked"
                @change="toggleAll({ done: !allChecked })"
            >
                Complete All
            </b-form-checkbox>
            <ul class="todo-list">
                <TodoItem v-for="(todo, index) in filteredTodos" :key="index" :todo="todo"></TodoItem>
            </ul>
        </section>
        <!-- footer -->
        <footer class="footer" v-show="todos.length">
            <span class="todo-count">
                <strong>{{ remaining }}</strong>
                {{ remaining | pluralize('item') }} left
            </span>
            <ul class="filters">
                <li v-for="(val, key) in filters" :key="key">
                    <a
                        :href="'#/' + key"
                        :class="{ selected: visibility === key }"
                        @click="visibility = key"
                    >
                        {{ key | capitalize }}
                    </a>
                </li>
            </ul>
            <button
                class="clear-completed"
                v-show="todos.length > remaining"
                @click="clearCompleted"
            >
                Clear completed
            </button>
        </footer>
    </section>
</template>

<script>
import { mapActions } from 'vuex'
import TodoItem from './TodoItem.vue'

const filters = {
    all: todos => todos,
    active: todos => todos.filter(todo => !todo.done),
    completed: todos => todos.filter(todo => todo.done)
}

export default {
    components: { TodoItem },

    data() {
        return {
            visibility: 'all',
            filters: filters
        }
    },

    computed: {
        todos() {
            return this.$store.state.storeTodo.todos
        },
        allChecked() {
            return this.todos.every(todo => todo.done)
        },
        filteredTodos() {
            return filters[this.visibility](this.todos)
        },
        remaining() {
            return this.todos.filter(todo => !todo.done).length
        }
    },

    methods: {
        addTodo(event) {
            let todoText = event.target.value;
            if (todoText.trim()) {
                this.$store.dispatch('addTodo', todoText)
            }
            event.target.value = '';
        },
        ...mapActions([
            'toggleAll',
            'clearCompleted'
        ])
    },

    filters: {
        pluralize: (n, w) => n === 1 ? w : (w + 's'),
        capitalize: s => s.charAt(0).toUpperCase() + s.slice(1)
    }
}
</script>

<style scoped>
    li {
        display: inline-block;
        border: 1px solid #DCDCDC;
        padding: 10px;
        margin: 10px;
    }

    .new-todo{
        width: 100%;
    }

    .toggle-all {
        margin-top: 20px;
    }

    ul {
        padding: 0px
    }
</style>
