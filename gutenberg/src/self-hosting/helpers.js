const helpers = {
    setUrlPrivate: ( baseCurrentUrl ) => {
		const newurl = baseCurrentUrl + '&file=spv-private';
		window.history.pushState( { path: newurl }, '', newurl );
	},
    unsetUrlPrivate: ( baseCurrentUrl ) => {
		window.history.pushState( { path: baseCurrentUrl }, '', baseCurrentUrl );
	}
}

export default helpers;
