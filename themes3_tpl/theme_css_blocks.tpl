<{foreach from=$positions item=bt}>
  .<{$bt.block_position}> .blockTitle{
    <{if $bt.bt_text_size|default:false}>font-size: <{$bt.bt_text_size}>;<{/if}>
    <{if $bt.bt_text|default:false}>color: <{$bt.bt_text}>;<{/if}>
    <{if $bt.bt_bg_color|default:false}>background-color: <{$bt.bt_bg_color}>;<{/if}>
    <{if $bt.bt_bg_img|default:false}>background-image: url(<{$bt.bt_bg_img}>);<{/if}>
    <{if $bt.bt_bg_repeat==0}>background-repeat: no-repeat;<{/if}>
    <{if $bt.bt_text_padding|default:false}>text-indent: <{$bt.bt_text_padding}>px;<{/if}>
    <{if $bt.bt_radius==1}>
    border-radius: 5px;
    -moz-border-radius: 5px;
    -webkit-border-radius: 5px;
    -khtml-border-radius: 5px;
    <{/if}>
  }

  .<{$bt.block_position}> a.block_config,
  .<{$bt.block_position}> a.tad_block_config{
    float:<{$bt.block_config}>;
    position: relative;
    z-index: 1;
  }

  <{if $bt.block_style|default:false}>
  .<{$bt.block_position}>{
    <{$bt.block_style}>
  }
  <{/if}>

  <{if $bt.block_title_style|default:false}>
  .<{$bt.block_position}> .blockTitle{
    <{$bt.block_title_style}>
  }
  <{/if}>

  <{if $bt.block_content_style|default:false}>
  .<{$bt.block_position}> .blockContent{
    <{$bt.block_content_style}>
  }
  <{/if}>

<{/foreach}>