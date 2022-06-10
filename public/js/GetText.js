function _trans(id) {
    if (transMessages[id] != undefined) {
        return transMessages[id];
    }
    
    return id;
}