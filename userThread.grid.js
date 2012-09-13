Quip.grid.user = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'quip-grid-user'
        ,url: '/maps/assets/components/quip/connector.php'
        ,baseParams: { action: 'mgr/user/getList' }
        ,fields: ['id', 'name', 'body', 'email', 'website']
        ,paging: true
        ,remoteSort: true
        ,anchor: '97%'
        ,autoExpandColumn: 'name'
        ,columns: [{
            header: 'id'
            ,dataIndex: 'id'
            ,sortable: true
            ,width: 60
        },{
            header: 'Name'
            ,dataIndex: 'name'
            ,sortable: true
            ,width: 100
            ,editor: { xtype: 'textfield' }
        },{
            header: 'Message'
            ,dataIndex: 'body'
            ,sortable: false
            ,width: 350
            ,editor: { xtype: 'textfield' }
        },{
            header: 'Featured'
            ,dataIndex: 'helpful'
            ,sortable: true
            ,width: 100
            ,editor: { xtype: 'textfield' }
        }
        ]
    });
    Quip.grid.user.superclass.constructor.call(this,config)
};
Ext.extend(Quip.grid.user,MODx.grid.Grid, {
    getMenu: function() {
            return [{
                text: "Update Comment"
                ,handler: this.updateComment
            },'-',{
                text: "Remove Comment"
                ,handler: this.removeComment
            },'-',{
                text: "Feature Comment"
                ,handler: this.featureComment
            }
            ,'-',{
                text: "Respond To Comment"
                ,handler: this.featureComment
            }
            ];
        },
    updateComment: function(btn,e) {
        if (!this.updateCommentWindow) {
            this.updateCommentWindow = MODx.load({
                xtype: 'quip-window-comment-update'
                ,record: this.menu.record
                ,listeners: {
                    'success': {fn:this.refresh,scope:this}
                }
            });
        }
        this.updateCommentWindow.setValues(this.menu.record);
        this.updateCommentWindow.show(e.target);
    }
    ,removeComment: function() {
        MODx.msg.confirm({
            title: _('warning')
            ,text: _('quip.comment_remove_confirm')
            ,url: this.config.url
            ,params: {
                action: 'mgr/comment/remove'
                ,id: this.menu.record.id
            }
            ,listeners: {
                'success': {fn:this.removeActiveRow,scope:this}
            }
        });
    }
    ,featureComment: function() {
        MODx.msg.confirm({
            title: _('FFFF')
            ,text: _('quip.comment_feature_confirm')
            ,url: this.config.url
            ,params: {
                action: 'mgr/user/feature'
                ,id: this.menu.record.id
            }
            ,listeners: {
                'success': {fn:this.refresh,scope:this}
            }
        });
    }
});
Ext.reg('quip-grid-user',Quip.grid.user);

Quip.window.UpdateComment = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        title: _('quip.comment_update')
        ,url: Quip.config.connector_url
        ,baseParams: {
            action: 'mgr/comment/update'
        }
        ,width: 600
        ,fields: [{
            xtype: 'hidden'
            ,name: 'id'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('quip.name')
            ,name: 'name'
            ,anchor: '90%'        
        },{
            xtype: 'textfield'
            ,fieldLabel: _('quip.email')
            ,name: 'email'
            ,anchor: '90%'        
        },{
            xtype: 'textfield'
            ,fieldLabel: _('quip.website')
            ,name: 'website'
            ,anchor: '90%'        
        },{
            xtype: 'statictextfield'
            ,fieldLabel: _('quip.ip')
            ,name: 'ip'
            ,anchor: '90%'
            ,submitValue: false
        },{
            xtype: 'textarea'
            ,hideLabel: true
            ,name: 'body'
            ,width: 550
            ,grow: true
        }]
        ,keys: []
    });
    Quip.window.UpdateComment.superclass.constructor.call(this,config);
};
Ext.extend(Quip.window.UpdateComment,MODx.Window);
Ext.reg('quip-window-comment-update',Quip.window.UpdateComment);