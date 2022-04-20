wp.domReady( () => {
  const registerBlocks = [
    'core/paragraph',
    'core/heading',
    'core/list',
    'core/image',
    'core/embed',
  ];
  wp.blocks.getBlockTypes().forEach( block => {
    if ( ! registerBlocks.includes( block.name ) ) {
      wp.blocks.unregisterBlockType( block.name );
    }
  } );

  const registerEmbedBlocks = [
    'youtube',

  ];
  wp.blocks.getBlockVariations( 'core/embed' ).forEach( block => {
    if ( ! registerEmbedBlocks.includes( block.name ) ) {
      wp.blocks.unregisterBlockVariation( 'core/embed', block.name );
    }
  } );
} );