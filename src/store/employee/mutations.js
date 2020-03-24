const updateDrawerState = (state, opened) => {
    state.drawerState = opened
}
const setEmployee = (state, employee) => {
    state.employee = employee
}

export {
    updateDrawerState,
    setEmployee
}
