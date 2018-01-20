export const TODO_ADD = 'todo_add'
export const TODO_DELETE = 'todo_delete'
export const TODO_TOGGLE = 'todo_toggle'
export const TODO_EDIT = 'todo_edit'
export const TODO_TOGGLE_ALL = 'todo_toggle_all'
export const TODO_CLEAR_COMPLETED = 'todo_clear_completed'

export const STORAGE_KEY = 'todos-vuejs'

// for testing
if (navigator.userAgent.indexOf('PhantomJS') > -1) {
    window.localStorage.clear()
}

const state = {
    todos: JSON.parse(window.localStorage.getItem(STORAGE_KEY) || '[]')
}

const mutations = {
    [TODO_ADD](state, { text }) {
        state.todos.push({
            text,
            done: false
        })
    },
    [TODO_DELETE](state, { todo }) {
        state.todos.splice(state.todos.indexOf(todo), 1)
    },
    [TODO_TOGGLE](state, { todo }) {
        todo.done = !todo.done
    },
    [TODO_EDIT](state, { todo, value }) {
        todo.text = value
    },
    [TODO_TOGGLE_ALL](state, { done }) {
        state.todos.forEach((todo) => {
            todo.done = done
        })
    },
    [TODO_CLEAR_COMPLETED](state) {
        state.todos = state.todos.filter(todo => !todo.done)
    }
}

const actions = {
    addTodo({ commit }, text) {
        commit(TODO_ADD, { text })
    },
    deleteTodo({ commit }, todo) {
        commit(TODO_DELETE, { todo })
    },
    toggleTodo({ commit }, todo) {
        commit(TODO_TOGGLE, { todo })
    },
    editTodo({ commit }, { todo, value }) {
        commit(TODO_EDIT, { todo, value })
    },
    toggleAll({ commit }, done) {
        commit(TODO_TOGGLE_ALL, { done })
    },
    clearCompleted({ commit }) {
        commit(TODO_CLEAR_COMPLETED)
    }
}

export default {
    state,
    actions,
    mutations
}
