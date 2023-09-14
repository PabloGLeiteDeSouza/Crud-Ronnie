/**
 * 
 * @param { String } dir 
 * @param { "head" | "body" | 'head'  | 'body' } location 
 */
function Include( dir, location ) {
    try {
        let new_script = document.createElement("script"); new_script.src = dir;
        document[location].appendChild(new_script);
    } catch (error) {
        
    } 
}