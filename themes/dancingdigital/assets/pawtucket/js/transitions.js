barba.init({
    transitions: [{
        sync: true,
        name: 'horizontal-slide',
        to: {
            namespace: ['about', 'ourstory'] // Add more namespaces for other pages
        },
        leave(data) {
            const ns = data.current.namespace;
            console.log('leaving', ns, data);

            const done = this.async();
    
            gsap.set(data.current.container, { x: '0%' });
            let x;
            switch(ns) {
                case 'ourstory':
                    x = '+100%';        // exit right
                    break;
                case 'about':
                default:
                    x = '-100%';        // exit left
                    break;
            }

            // Use GSAP to animate the current page sliding out to the left
            gsap.to(data.current.container, {
                x: x,
                onComplete: done,
            });
        },
        enter(data) {
            const ns = data.next.namespace;
            console.log('entering', ns, data);
            
            // gsap.to(".page-heading", { x: 100, y: 200 })
            
            switch(ns) {
                case 'ourstory':
                    gsap.set(data.next.container, { x: '100%' });       // position to right
                    break;
                case 'about':
                default:
                    gsap.set(data.next.container, { x: '-100%' });      // position to left
                    break;
            }


            // Use GSAP to animate the new page sliding in from the right
            gsap.to(data.next.container, {
                x: '0%',
                onComplete: () => {
                    // Cleanup and reset position
                    gsap.set(data.next.container, { clearProps: 'transform' });
                },
            });
        }
    }]
});

